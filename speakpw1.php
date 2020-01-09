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
            font-size: 32px;
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
        var pwList = [];
        var pwString = "";
        var rate = .5;
        var continuous_flag = false;
        var contVar;
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
        <button class="next-button" onclick="contVar = setInterval(next, 2000)">Continuous</button>
        <!-- <button class="next-button" onclick="slower()">Slower</button>
        <button class="next-button" onclick="faster()">Faster</button> -->
        <br><br>
        <div id="pw-div"></div>
        <br><br>
        <!-- <a href="get_password.html">Change Password</a> -->
        <button class="new-password" onclick="window.location.href = 'index.html';">Change Password</button>
    </main>

    <?php

    function add($c, $s, $i)
    {
        echo "speakList[" . $i . "] = '" . $s . "';";
        echo "pwList[" . $i . "] = '" . $c . "';";
    }

    $pw = '';
    echo "<script>";
    if (isset($_POST["password"])) {
        $pw = $_POST["password"];
    } else {
        $pw = 'oj C#Q{[a%t$F@9!OHv3qM';
    }

    echo 'document.getElementById("original-pw").innerHTML = "' . $pw . '";';

    $n = strlen($pw);
    for ($i = 0; $i < $n; $i++) {
        $c = substr($pw, $i, 1);

        if ($c >= "A" && $c <= "Z") {
            add($c, "capital " . $c, $i);
        } else if ($c >= "0" && $c <= "9") {
            add($c, $c, $i);
        } else if ($c == "$") {
            add($c, $c, $i);
        } else if ($c == "!") {
            add($c, "exlamation", $i);
        } else if ($c == "&") {
            add($c, "apper sand", $i);
        } else if ($c == "^") {
            add($c, "carrot", $i);
        } else if ($c == "@") {
            add($c, "at sign", $i);
        } else if ($c == "(") {
            add($c, "left parentheses", $i);
        } else if ($c == ")") {
            add($c, "right parentheses", $i);
        } else if ($c == "[") {
            add($c, "left square bracket", $i);
        } else if ($c == "]") {
            add($c, "right square bracket", $i);
        } else if ($c == "_") {
            add($c, "underscore", $i);
        } else if ($c == "-") {
            add($c, "dash", $i);
        } else if ($c == "|") {
            add($c, "vertical bar", $i);
        } else if ($c == "{") {
            add($c, "left curly brace", $i);
        } else if ($c == "}") {
            add($c, "right curly brace", $i);
        } else if ($c == ",") {
            add($c, "comma", $i);
        } else if ($c == ":") {
            add($c, "colon", $i);
        } else if ($c == ";") {
            add($c, "semi colon", $i);
        } else if ($c == "?") {
            add($c, "question mark", $i);
        } else if ($c == " ") {
            add($c, "space", $i);
        } else if ($c == "e") {
            add($c, "ee", $i);
        } else if ($c == "o") {
            add($c, "ooh", $i);
        } else if ($c == "a") {
            add($c, "A", $i);
        } else {
            add($c, $c, $i);
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
            if (SpeechRecognition != null) {
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
            if (command.includes("next") || command.includes("again")) {
                next();
            }
            if (command.includes("previous")) {
                back();
            }
            if (command.includes("skip")) {
                skip();
            }
            if (command.includes("continuous")) {
                continuous1();
            }
            if (command.includes("quit")) {
                quit();
            }
        };

        function quit() {
            window.location.assign("index.html")
        }

        function continuous() {
            // const len = speakList.length;
            // while ( index < len ) {
            //     speechSynthesis.addEventListener('end', continuous2());
            //     speak(speakList[index]);
            // }
        }

        function continuous1() {
            continuous_flag = true;
            speechSynthesis.addEventListener('end', continuous2());
            const i = index;
            index++;
            speak(speakList[i]);
            document.getElementById("pw-div").innerHTML = updatePWstring(pwList[i]);
        }
        
        function continuous2() {
            document.getElementById("pw-div").innerHTML = updatePWstring(pwList[index++]);
        }

        function updatePWstring(c) {
            pwString = pwString.concat(c);
            return pwString;
        }

        function next() {
            var id = document.getElementById("pw-div");
            var s = "";
            var c = "";
            if (index >= speakList.length) {
                clearInterval(contVar);
                pwString = s = "Password Complete";
                index = 0;
            } else {
                s = speakList[index];
                c = pwList[index];
                index++;
            }
            id.innerHTML = updatePWstring(c);
            speak(s);
        }

        function nextWithoutAdvance() {
            var id = document.getElementById("pw-div");
            var s = speakList[index];
            c = pwList[index];
            // index++;
            if (index >= speakList.length) {
                index = 0;
            }
            id.innerHTML = updatePWstring(c);
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
            // if ( continuous_flag ) {
            //     speechSynthesis.addEventListener('end', continuous2());
            // }
            speechSynthesis.speak(msg);
        }
    </script>
</body>

</html>