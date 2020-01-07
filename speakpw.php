<html>

<head>
    <title>Password Speaker</title>
    <style>
        #original-pw {
            /* width: 200px; */
            height: 50px;
            /* border: 3px solid red; */
            color: black;
            font-size: 32px;
        }

        #pw-div {
            width: 200px;
            height: 50px;
            /* border: 3px solid red; */
            color: black;
        }

        .next-button {
            /* width: 100px; */
            height: 50px;
            font-size: 32px;
        }

        #pw-div {
            width: 100%;
            font-size: 48px;
        }

        .new-password {
            padding-top: 25px;
            font-size: 32px;
            /* border: 3px solid black; */
            text-decoration: none;
            color: black;
        }

        .voice-commands {
            height: 50px;
            font-size: 32px;

        }

        .voice-values {
            font-size: 22px;
        }
    </style>
</head>

<body>
    <script>
        var index = 0;
        var speakList = [];
        var rate = .5;
    </script>
    <main id="main-id" class="">
        <br><br>
        <div id="original-pw"></div>
        <button id="voice-commands-id" class="voice-commands" onclick="voiceCommands()">Use Voice Commands</button>
        <br><br>
        <div class="voice-values">
            Voice Rate: <input class="voice-values" id="voice-rate" type="text" value="1.0">
            <span>(0 - 10)</span>
            <br>
            Voice Pitch: <input class="voice-values" id="voice-pitch" type="text" value="1.0">
            <span>Legal values: (0 - 2)</span>
        </div>
        <br><br>
        <button class="next-button" onclick="back()">Previous</button>
        <button class="next-button" onclick="next()">Next</button>
        <button class="next-button" onclick="skip()">Skip</button>
        <button class="next-button" onclick="continuous()">Continuous</button>
        <!-- <button class="next-button" onclick="slower()">Slower</button>
        <button class="next-button" onclick="faster()">Faster</button> -->
        <br><br>
        <div id="pw-div"></div>
        <br><br>
        <!-- <a href="get_password.html">Change Password</a> -->
        <button class="new-password" onclick="window.location.href = 'index.html';">Change Password</button>
    </main>

    <?php

    function add($s, $i)
    {
        echo "speakList[" . $i . "] = '" . $s . "';";
    }

    $pw = '';
    echo "<script>";
    if ( isset($_POST["password"]) ) {
        $pw = $_POST["password"];
    } else {
        $pw = 'oj C#Q{[a%t$F@9!OHv3qM';
    }

    echo 'document.getElementById("original-pw").innerHTML = "' . $pw . '";';

    $n = strlen($pw);
    for ($i = 0; $i < $n; $i++) {
        $c = substr($pw, $i, 1);

        if ($c >= "A" && $c <= "Z") {
            add("capital " . $c, $i);
        } else if ($c >= "0" && $c <= "9") {
            add($c, $i);
        } else if ($c == "$") {
            add($c, $i);
        } else if ($c == "!") {
            add("exlamation", $i);
        } else if ($c == "&") {
            add("apper sand", $i);
        } else if ($c == "^") {
            add("carrot", $i);
        } else if ($c == "@") {
            add("at sign", $i);
        } else if ($c == "(") {
            add("left parentheses", $i);
        } else if ($c == ")") {
            add("right parentheses", $i);
        } else if ($c == "[") {
            add("left square bracket", $i);
        } else if ($c == "]") {
            add("right square bracket", $i);
        } else if ($c == "_") {
            add("underscore", $i);
        } else if ($c == "-") {
            add("dash", $i);
        } else if ($c == "|") {
            add("vertical bar", $i);
        } else if ($c == "{") {
            add("left curly brace", $i);
        } else if ($c == "}") {
            add("right curly brace", $i);
        } else if ($c == ",") {
            add("comma", $i);
        } else if ($c == ":") {
            add("colon", $i);
        } else if ($c == ";") {
            add("semi colon", $i);
        } else if ($c == "?") {
            add("question mark", $i);
        } else if ($c == " ") {
            add("space", $i);
        } else if ($c == "e") {
            add("ee", $i);
        } else if ($c == "o") {
            add("ooh", $i);
        } else if ($c == "a") {
            add("A", $i);
        } else {
            add($c, $i);
        }
    }
    echo "</script>";
    ?>
    <script>
        // const button = document.querySelector('.talk');
        // const content = document.querySelector('.content');

        // const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        // const recognition = new SpeechRecognition();
        try {
            var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if ( SpeechRecognition != null ) {
                var recognition = new SpeechRecognition();
                document.getElementById("pw-div").textContent = 'Speech recognition initialized';
            } else {
                document.getElementById("voice-commands-id").style.display = "none";
            }
        } catch (e) {
            document.getElementById("pw-div").textContent = e.message;
        }

        function voiceCommands() {
            recognition.continuous = true;
            recognition.start();
        }

        recognition.onresult = function(event) {
            const current = event.resultIndex;
            var command = event.results[current][0].transcript;
            // command = command.trim();
            // if ( command == 'next') {
            //     next();
            // }
            if ( command.includes("next") || command.includes("again") ) {
                next();
            }
            if ( command.includes("previous") ) {
                back();
            }
            if ( command.includes("skip") ) {
                skip();
            }
            if ( command.includes("continuous") ) {
                continuous();
            }
            if ( command.includes("quit") ) {
                quit();
            }
        };

        function quit() {
            window.location.assign("index.html")
        }

        function continuous() {
            for (i = 0; i < speakList.length; i++) {
                speak(speakList[i]);
            }
        }

        function next() {
            var id = document.getElementById("pw-div");
            var s = "";            
            if ( index >= speakList.length) {
                s = "Password Complete";
                index = 0;
            } else {
                s = speakList[index];
                index++;
            }
            id.innerHTML = s;
            speak(s);
        }

        function nextWithoutAdvance() {
            var id = document.getElementById("pw-div");
            var s = speakList[index];
            // index++;
            if (index >= speakList.length) {
                index = 0;
            }
            id.innerHTML = s;
            speak(s);
        }
        function back() {
            if (index != 0) {
                index--;
            }
            if (index < 0) {
                index = 0;
            }
            // next();
            nextWithoutAdvance();
        }

        function skip() {
            if (index != 0) {
                index++;
            }
            // next();
        }

        function slower() {
            rate -= 0.25;
        }

        function faster() {
            rate += 0.25;
        }

        function speak(str) {
            var msg = new SpeechSynthesisUtterance();
            msg.rate = document.getElementById('voice-rate').value;
            msg.pitch = document.getElementById('voice-pitch').value;
            msg.text = str;
            speechSynthesis.speak(msg);
        }
    </script>
</body>

</html>