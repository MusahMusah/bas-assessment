<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary Payment Date tool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&family=Quicksand:wght@400;500&display=swap"
          rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }

        html {
            background: url('/bg.png') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        #page-wrap {
            width: 600px;
            margin: 200px auto;
            padding: 20px;
            background: white;
            -moz-box-shadow: 0 0 20px black;
            -webkit-box-shadow: 0 0 20px black;
            box-shadow: 0 0 20px black;
        }

        h2 {
            text-align: center;
        }

        .content {
            margin: 50px 10px;
            display: flex;
            justify-content: space-between;
        }

        .content > button {
            flex-basis: 20%;
        }

        .content > label {
            flex-basis: 70%;
            margin-right: 1rem;
        }

        select {
            width: 100%;
            padding: 10px 35px 10px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: url(http://tuckeralbin.com/wp-content/uploads/intense-cache/icons/plugin/font-awesome/angle-double-down.svg);
            background-repeat: no-repeat;
            background-size: 10%;
            background-position: 98% 50%;
        }

        select::-ms-expand {
            display: none; /* remove default arrow on ie10 and ie11 */
        }

        .buttonDownload {
            display: inline-block;
            position: relative;
            padding: 10px 25px;

            background-color: darkblue;
            color: white;

            font-family: sans-serif;
            text-decoration: none;
            font-size: 0.9em;
            text-align: center;
            text-indent: 15px;
        }

        .buttonDownload:hover {
            background-color: #333;
            color: white;
        }

        .buttonDownload:before, .buttonDownload:after {
            content: ' ';
            display: block;
            position: absolute;
            left: 15px;
            top: 52%;
        }

        /* Download box shape  */
        .buttonDownload:before {
            width: 10px;
            height: 2px;
            border-style: solid;
            border-width: 0 2px 2px;
        }

        /* Download arrow shape */
        .buttonDownload:after {
            width: 0;
            height: 0;
            margin-left: 3px;
            margin-top: -7px;

            border-style: solid;
            border-width: 4px 4px 0 4px;
            border-color: transparent;
            border-top-color: inherit;

            animation: downloadArrow 2s linear infinite;
            animation-play-state: paused;
        }

        .buttonDownload:hover:before {
            border-color: #4CC713;
        }

        .buttonDownload:hover:after {
            border-top-color: #4CC713;
            animation-play-state: running;
        }

        /* keyframes for the download icon anim */
        @keyframes downloadArrow {
            /* 0% and 0.001% keyframes used as a hackish way of having the button frozen on a nice looking frame by default */
            0% {
                margin-top: -7px;
                opacity: 1;
            }

            0.001% {
                margin-top: -15px;
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                margin-top: 0;
                opacity: 0;
            }
        }

        button {
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="page-wrap">
    <h2>
        Salary Payment Date tool
    </h2>

    <form method="GET" action="{{ route('salary.payment-date') }}">
        <div class="content">
            <label>
                <select name="year">
                    <option value="{{ date('Y') }}">Current Year</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </label>

            <button type="submit" class="buttonDownload">Download CSV</button>
        </div>
    </form>
</div>
</body>
</html>
