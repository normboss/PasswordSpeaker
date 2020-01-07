$(function () {
    if ('speechSynthesis' in window) {
        speechSynthesis.onvoiceschanged = function () {
            var $voicelist = $('#voices');

            if ($voicelist.find('option').length == 0) {
                speechSynthesis.getVoices().forEach(function (voice, index) {
                    var $option = $('<option>')
                        .val(index)
                        .html(voice.name + (voice.default ? ' (default)' : ''));

                    $voicelist.append($option);
                });

                $voicelist.material_select();
            }
        }

        $('#speak').click(function () {
            var text = $('#message').val();
            var voices = window.speechSynthesis.getVoices();
            // msg.voice = voices[$('#voices').val()];
            // msg.rate = $('#rate').val() / 10;
            // msg.pitch = $('#pitch').val();

            function sleep(milliseconds) {
                var start = new Date().getTime();
                for (var i = 0; i < 1e7; i++) {
                    if ((new Date().getTime() - start) > milliseconds) {
                        break;
                    }
                }
            }

            function speak(str) {
                var msg = new SpeechSynthesisUtterance();
                msg.voice = voices[$('#voices').val()];
                msg.rate = 0.25
                msg.pitch = $('#pitch').val();
                msg.text = str;
                speechSynthesis.speak(msg);
                // sleep(3000);l
                
            }

            for (let i = 0; i < text.length; i++) {
                var c = text.charAt(i);

                if (c >= 'A' && c <= 'Z') {
                    speak('capital ' + c)
                } else if (c >= '0' && c <= '9') {
                    speak(c)
                } else if (c == '$') {
                    speak(c)
                } else if (c == '!') {
                    speak('exlamation')
                } else if (c == '&') {
                    speak('appersand')
                } else if (c == '^') {
                    speak('carrot')
                } else if (c == '@') {
                    speak('at sign')
                } else if (c == '(') {
                    speak('left paren')
                } else if (c == ')') {
                    speak('right paren')
                } else if (c == '_') {
                    speak('underscore')
                } else if (c == '-') {
                    speak('dash')
                } else if (c == '|') {
                    speak('vertical bar')
                } else if (c == '{') {
                    speak('left curly brace')
                } else if (c == '}') {
                    speak('right curly brace')
                } else if (c == ',') {
                    speak('comma')
                } else if (c == ':') {
                    speak('colon')
                } else if (c == ';') {
                    speak('semi colon')
                } else {
                    speak(c)
                }
            }

        })
    } else {
        $('#modal1').openModal();
    }
});