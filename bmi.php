<?php
$weightInput = isset($_POST['weight']) && is_string($_POST['weight']) ? trim($_POST['weight']) : '';
$heightInput = isset($_POST['height']) && is_string($_POST['height']) ? trim($_POST['height']) : '';
$isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$error = '';
$bmi = null;

if ($isSubmitted) {
    if (!is_numeric($weightInput) || !is_numeric($heightInput)) {
        $error = 'Enter a valid weight and height.';
    } elseif ((float) $weightInput <= 0 || (float) $heightInput <= 0) {
        $error = 'Weight and height must be greater than zero.';
    } else {
        $weight = (float) $weightInput;
        $height = (float) $heightInput;
        $bmi = ($weight / ($height * $height)) * 703;
    }
}

$escapedWeight = htmlspecialchars($weightInput, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$escapedHeight = htmlspecialchars($heightInput, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple BMI Calculator</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
            color: #202a31;
            background: #f1f5f4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        main {
            width: min(100%, 440px);
            padding: 32px;
            border: 1px solid #d8e1de;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 12px 34px rgb(32 42 49 / 8%);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 1.7rem;
        }

        .intro {
            margin: 0 0 24px;
            color: #56656b;
            line-height: 1.5;
        }

        .result {
            margin: 0 0 24px;
            padding: 16px;
            border-left: 4px solid #167d70;
            background: #edf7f4;
        }

        .result strong {
            display: block;
            margin-top: 4px;
            font-size: 1.7rem;
        }

        .error {
            margin: 0 0 20px;
            color: #a22c2c;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 44px;
            padding: 10px 12px;
            border: 1px solid #aebbb7;
            border-radius: 4px;
            font: inherit;
        }

        input:focus {
            border-color: #167d70;
            outline: 3px solid rgb(22 125 112 / 18%);
        }

        button {
            width: 100%;
            min-height: 46px;
            border: 0;
            border-radius: 4px;
            background: #126e63;
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #0d594f;
        }

        .note {
            margin: 20px 0 0;
            color: #66747a;
            font-size: 0.88rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <main>
        <h1>Simple BMI Calculator</h1>
        <p class="intro">Enter your weight and height to calculate your body mass index.</p>

        <?php if ($bmi !== null): ?>
            <p class="result" role="status">
                Your BMI is
                <strong><?= number_format($bmi, 1) ?></strong>
            </p>
        <?php elseif ($error !== ''): ?>
            <p class="error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="bmi.php">
            <div class="field">
                <label for="weight">Weight (pounds)</label>
                <input id="weight" name="weight" type="number" min="0" step="any" value="<?= $escapedWeight ?>" required>
            </div>
            <div class="field">
                <label for="height">Height (inches)</label>
                <input id="height" name="height" type="number" min="0" step="any" value="<?= $escapedHeight ?>" required>
            </div>
            <button type="submit">Calculate BMI</button>
        </form>

        <p class="note">BMI is calculated using weight in pounds and height in inches.</p>
    </main>
</body>
</html>