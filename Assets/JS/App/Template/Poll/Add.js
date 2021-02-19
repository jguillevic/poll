import * as Message from "../../Resources/Message/CommonMessage.js";

window.addEventListener('load', function() {
    console.log("poll add form load");

    let questionInput = document.getElementById("question");
    let questionErrors = document.getElementById("question_errors");
    let questionGroup = document.getElementById("question_group");
    questionInput.addEventListener("keydown", function(){
        console.log("question key down");
        questionGroup.classList.remove("f-group-errors");
        if (questionErrors !== null) {
            questionErrors.innerHTML = "";
        }
    });

    let answer1Input = document.getElementById("answer_1");
    let answer1Errors = document.getElementById("answer_1_errors");
    let answer1Group = document.getElementById("answer_1_group");
    answer1Input.addEventListener("keydown", function(){
        console.log("answer_1 key down");
        answer1Group.classList.remove("f-group-errors");
        if (answer1Errors !== null) {
            answer1Errors.innerHTML = "";
        }
    });

    let answer2Input = document.getElementById("answer_2");
    let answer2Errors = document.getElementById("answer_2_errors");
    let answer2Group = document.getElementById("answer_2_group");
    answer2Input.addEventListener("keydown", function(){
        console.log("answer_2 key down");
        answer2Group.classList.remove("f-group-errors");
        if (answer2Errors !== null) {
            answer2Errors.innerHTML = "";
        }
    });

    let answer3Input = document.getElementById("answer_3");
    let answer3Errors = document.getElementById("answer_3_errors");
    let answer3Group = document.getElementById("answer_3_group");
    answer3Input.addEventListener("keydown", function(){
        console.log("answer_3 key down");
        answer3Group.classList.remove("f-group-errors");
        if (answer3Errors !== null) {
            answer3Errors.innerHTML = "";
        }
    });

    let answer4Input = document.getElementById("answer_4");
    let answer4Errors = document.getElementById("answer_4_errors");
    let answer4Group = document.getElementById("answer_4_group");
    answer4Input.addEventListener("keydown", function(){
        console.log("answer_4 key down");
        answer4Group.classList.remove("f-group-errors");
        if (answer4Errors !== null) {
            answer4Errors.innerHTML = "";
        }
    });

    let answer5Input = document.getElementById("answer_5");
    let answer5Errors = document.getElementById("answer_5_errors");
    let answer5Group = document.getElementById("answer_5_group");
    answer5Input.addEventListener("keydown", function(){
        console.log("answer_5 key down");
        answer5Group.classList.remove("f-group-errors");
        if (answer5Errors !== null) {
            answer5Errors.innerHTML = "";
        }
    });
});