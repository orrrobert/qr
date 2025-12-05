<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Generator</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      text-align: center;
    }
    form {
      display: inline-block;
      text-align: left;
    }
    label {
      display: block;
      margin: 10px 0 5px;
    }
    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
    button {
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    #qrcode {
      margin-top: 20px;
    }
    .checkbox-label {
      display: flex;
      align-items: center;
      margin: 10px 0;
    }
    .checkbox-label input {
      width: auto;
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <h1>QR Code Generator</h1>
  <?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $marketingOptIn = isset($_POST['marketingOptIn']) ? 'true' : 'false';
    $timestamp = date("Y-m-d H:i:s");

    $data = [
      'firstName' => $firstName,
      'lastName' => $lastName,
      'email' => $email,
      'marketingOptIn' => $marketingOptIn,
      'timestamp' => $timestamp
    ];

    // Save data to a file
    $file = 'data.json';
    $jsonData = json_encode($data);
    file_put_contents($file, $jsonData . PHP_EOL, FILE_APPEND);

    // Format QR Code data with pipe separators
    $qrData = "$firstName|$lastName|$email|$marketingOptIn";

    echo "<div id='qrcode'></div>";
    echo "<p>Please show this code to the photographer right before your photo session.</p>";
    echo "<script>
      new QRCode(document.getElementById('qrcode'), {
        text: '$qrData',
        width: 200,
        height: 200,
      });
    </script>";
  } else {
  ?>
  <form method="post" action="">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required autocomplete="given-name">

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required autocomplete="family-name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required autocomplete="email">

    <div class="checkbox-label">
      <input type="checkbox" id="marketingOptIn" name="marketingOptIn" checked>
      <label for="marketingOptIn">Yes, I'd like to receive marketing emails.</label>
    </div>

    <button type="submit">Generate QR Code</button>
  </form>
  <?php
  }
  ?>
</body>
</html>

