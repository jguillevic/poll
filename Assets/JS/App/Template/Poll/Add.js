import * as Message from "../../Resources/Message/CommonMessage.js";

window.addEventListener('load', function() {
    console.log("poll add form load");

    let form = document.getElementById("form");

    let questionInput = document.getElementById("question");
    let questionErrors = document.getElementById("question_errors");
    if (questionErrors.children.length > 0) {
        console.log("has quetion errors");
        questionInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let answer1Input = document.getElementById("answer_1");
    let answer1Errors = document.getElementById("answer_1_errors");
    if (answer1Errors.children.length > 0) {
        console.log("has answer_1 errors");     
        answer1Input.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let answer2Input = document.getElementById("answer_2");
    let answer2Errors = document.getElementById("answer_2_errors");
    if (answer2Errors.children.length > 0) {
        console.log("has answer_2 errors");     
        answer2Input.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let answer3Input = document.getElementById("answer_3");
    let answer3Errors = document.getElementById("answer_3_errors");
    if (answer3Errors.children.length > 0) {
        console.log("has answer_3 errors");     
        answer3Input.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let answer4Input = document.getElementById("answer_4");
    let answer4Errors = document.getElementById("answer_4_errors");
    if (answer4Errors.children.length > 0) {
        console.log("has answer_4 errors");     
        answer4Input.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let answer5Input = document.getElementById("answer_5");
    let answer5Errors = document.getElementById("answer_5_errors");
    if (answer5Errors.children.length > 0) {
        console.log("has answer_5 errors");     
        answer5Input.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    questionInput.addEventListener("keydown", function(){
        console.log("question key down");
        questionErrors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    answer1Input.addEventListener("keydown", function(){
        console.log("answer_1 key down");
        answer1Errors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    answer2Input.addEventListener("keydown", function(){
        console.log("answer_2 key down");
        answer2Errors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    answer3Input.addEventListener("keydown", function(){
        console.log("answer_3 key down");
        answer3Errors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    answer4Input.addEventListener("keydown", function(){
        console.log("answer_4 key down");
        answer4Errors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    answer5Input.addEventListener("keydown", function(){
        console.log("answer_5 key down");
        answer5Errors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });
});