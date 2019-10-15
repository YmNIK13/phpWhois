<!DOCTYPE html>
<html lang="en">
<head>
    <title>whois.php -base classes to do whois queries with php</title>
    <style type="text/css">
        body {
            overflow-x: hidden;
            position: relative;
        }

        main {
            width: 100%;
            min-height: 200px;
            padding: 10px;
        }

        p {
            margin: 0;
            padding: 5px 0;
            line-height: 1.2;
        }

        .container {
            width: 1200px;
            margin: 0 auto;
        }


        h1 {
            text-align: center;
        }

        form {
            background-color: #55aaff;
            padding: 10px;
            position: relative;
        }

        form input {
            margin: 5px;
        }

        form label,
        form input[type="radio"],
        form input[type="checkbox"] {
            cursor: pointer;
        }

        form img {
            border: 0 solid;
        }

        .logo-form {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        footer {
            width: 100%;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <h1>phpWhois <?= $ver ?? '' ?> - base class to do whois queries with php</h1>
        <form method="get" action="<?= $self ?? '' ?>">
            <div>
                <b>Enter any domain name, ip address or AS handle you would like to query whois for</b>
                <br/><br/>
                <input name="query" value="<?= $get_params['query'] ?? '' ?>"/>
                <input type="submit" value="Whois"/><br/>
            </div>
            <div>
                <div>
                    <input id="output_normal" type="radio" name="output" value="normal" <?= $get_params['output'] == "normal" ? 'checked="checked"' : '' ?> />
                    <label for="output_normal">Show me regular output</label>
                </div>
                <div>
                    <input id="output_nice" type="radio" name="output" value="nice" <?= $get_params['output'] == "nice" ? 'checked="checked"' : '' ?> />
                    <label for="output_nice">Show me HTMLized output</label>
                </div>
                <div>
                    <input id="output_object" type="radio" name="output" value="object"<?= $get_params['output'] == "object" ? 'checked="checked"' : '' ?> />
                    <label for="output_object">Show me the returned PHP object</label>
                </div>
                <div>
                    <input id="fast" type="checkbox" name="fast" value="1" <?= $get_params['fast'] ? 'checked="checked"' : '' ?> />
                    <label for="fast">Fast lookup</label>
                </div>
            </div>

            <div class="logo-form"><a href="http://www.phpwhois.org" title="phpWhois web page"><img src="whois.icon.png" alt="phpWhois web page"/></a></div>
        </form>
    </div>
</header>


<main>
    <div class="container">
        <?php if (!empty($query)) { ?>
            <div><strong>Results for <?= $query ?> :</strong></div>
            <blockquote>
                <?= $winfo ?? '' ?>
            </blockquote>
        <?php } ?>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 1999 - 2011 <a href="http://www.easydns.com/">easyDNS Technologies Inc.</a> &amp; <a href="http://mark.jeftovic.net/">Mark Jeftovic</a></p>
        <p>Now maintained and hosted by David Saez at <a href="http://www.ols.es">OLS 20000</a></p>
        <p>Placed under the GPL. See the LICENSE file in the distribution.</p>
    </div>
</footer>

</body>
</html>