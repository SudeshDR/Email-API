<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Authentication API @Sudesh</title>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --color-light: white;
            --color-dark: #212121;
            --color-signal: #fab700;
          
            --color-background: var(--color-light);
            --color-text: var(--color-dark);
            --color-accent: var(--color-signal);
          
            --size-bezel: .5rem;
            --size-radius: 4px;
          
            line-height: 1.4;
          
            font-family: 'Inter', sans-serif;
            font-size: calc(.6rem + .4vw);
            color: var(--color-text);
            background: var(--color-background);
            font-weight: 300;
            padding: 0 calc(var(--size-bezel) * 3);
        }

        h1, h2, h3 {
            font-weight: 900;
        }

        mark {
            background: var(--color-accent);
            color: var(--color-text);
            font-weight: bold;
            padding: 0 0.2em;
        }

        .card {
            background: var(--color-background);
            padding: calc(4 * var(--size-bezel));
            margin-top: calc(4 * var(--size-bezel));
            border-radius: var(--size-radius);
            border: 3px solid var(--color-shadow, currentColor);
            box-shadow: .5rem .5rem 0 var(--color-shadow, currentColor);
            max-width: 40rem;
            padding: 1rem;
        }

        .response-box {
            width: 100%;
            margin-top: 1rem;
        }

        .response-box textarea {
            width: calc(50% - 0.5rem);
            padding: 0.5rem;
            margin-right: 0.5rem;
            border-radius: var(--size-radius);
            border: 1px solid var(--color-accent);
            box-sizing: border-box;
            resize: none;
        }

        .l-design-width {
            max-width: 40rem;
            padding: 1rem;
            margin: auto;
            text-align: center;
        }

        .input {
            position: relative;

            &__label {
                position: absolute;
                left: 0;
                top: 0;
                padding: calc(var(--size-bezel) * 0.75) calc(var(--size-bezel) * .5);
                margin: calc(var(--size-bezel) * 0.75 + 3px) calc(var(--size-bezel) * .5);
                background: pink;
                white-space: nowrap;
                transform: translate(0, 0);
                transform-origin: 0 0;
                background: var(--color-background);
                transition: transform 120ms ease-in;
                font-weight: bold;
                line-height: 1.2;
            }
            
            &__field {
                box-sizing: border-box;
                display: block;
                width: 100%;
                border: 3px solid currentColor;
                padding: calc(var(--size-bezel) * 1.5) var(--size-bezel);
                color: currentColor;
                background: transparent;
                border-radius: var(--size-radius);
              
                &:focus,
                &:not(:placeholder-shown) {
                    & + .input__label {
                        transform: translate(.25rem, -65%) scale(.8);
                        color: var(--color-accent);
                    }
                }
            }
        }

        .button-group {
            margin-top: calc(var(--size-bezel) * 2.5);
        }

        button {
            color: currentColor;
            padding: var(--size-bezel) calc(var(--size-bezel) * 2);
            background: var(--color-accent);
            border: none;
            border-radius: var(--size-radius);
            font-weight: 900;

            &[type=reset] {
                background: var(--color-background);
                font-weight: 200;
            }
        }

        button + button {
            margin-left: calc(var(--size-bezel) * 2);
        }

        .icon {
            display: inline-block;
            width: 1em; height: 1em;
            margin-right: .5em;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="l-design-width">
        <h1>Email Authentication API @Sudesh</h1>

        <div class="card">
            <form action="" method="post">
                <div class="input">
                    <label for="email" class="input__label">Email:</label>
                    <input type="email" id="email" name="email" class="input__field" required>
                </div>
                <div class="button-group">
                    <button type="submit">Validate Email</button>
                    <button type="reset">Reset</button>
                </div>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $api_key = "8ed80efd796e4509a23e5ddeec8872db";  // Replace with your actual API key
                $email = $_POST["email"];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=" . urlencode($api_key) . "&email=" . urlencode($email),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $responseData = json_decode($response, true);
                    echo "<div class='response-box'>";
                    echo "<textarea readonly>{$responseData['email']} - {$responseData['deliverability']}</textarea>";
                    echo "<textarea readonly>{$responseData['is_valid_format']['text']} - {$responseData['is_free_email']['text']}</textarea>";
                    echo "<textarea readonly>Quality Score: {$responseData['quality_score']}</textarea>";
                    echo "<textarea readonly>SMTP Valid: {$responseData['is_smtp_valid']['text']} - MX Found: {$responseData['is_mx_found']['text']}</textarea>";
                    echo "<textarea readonly>Catch-All Email: {$responseData['is_catchall_email']['text']} - Role Email: {$responseData['is_role_email']['text']}</textarea>";
                    echo "<textarea readonly>Disposable Email: {$responseData['is_disposable_email']['text']} - Free Email: {$responseData['is_free_email']['text']}</textarea>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
