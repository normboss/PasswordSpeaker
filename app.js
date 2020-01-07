
const button = document.querySelector('.talk');
const content = document.querySelector('.content');

// const SpeechRecognition;
// const recognition;
try {
    var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    var recognition = new SpeechRecognition();
    var myContinuous = recognition.continuous;
    recognition.continuous = true;
    content.textContent = 'Speech recognition initialized';
} catch(e) {
    content.textContent = e.message;
}

recognition.onstart = function() {
    const s = 'voice is activated, you can use the microphone';
    console.log(s);
    content.textContent = s;
};

recognition.onspeechend = function() {
    const s = 'voice is de-activated';
    content.textContent = s;
};

recognition.onresult = function(event) {
    const current = event.resultIndex;
    const transcript = event.results[current][0].transcript;
    content.textContent = transcript;
    readOutLoad(transcript);
};

button.addEventListener('click', () => {
    recognition.start();
});

function readOutLoad(message) {
    const speech = new SpeechSynthesisUtterance();
    speech.text = message;
    speech.volume = 1;
    speech.rate = 0.5;
    speech.pitch = 1;
    window.speechSynthesis.speak(speech);
    // speech.speak();
};