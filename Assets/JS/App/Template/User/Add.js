import * as LoginChecker from "../../BLL/User/LoginChecker.js";
import * as PasswordChecker from "../../BLL/User/PasswordChecker.js";
import * as Message from "../../Resources/Message/CommonMessage.js";

window.addEventListener('load', function() {
    console.log("user login form load");

    let form = document.getElementById("form");

    let loginInput = document.getElementById("login");
    let loginErrors = document.getElementById("login_errors");
    if (loginErrors.children.length > 0) {
        console.log("has login errors");
        loginInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let emailInput = document.getElementById("email");
    let emailErrors = document.getElementById("email_errors");
    if (emailErrors.children.length > 0) {
        console.log("has email errors");     
        emailInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    let passwordInput = document.getElementById("password");
    let passwordErrors = document.getElementById("password_errors");
    if (passwordErrors.children.length > 0) {
        console.log("has password errors");     
        passwordInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
    }

    loginInput.addEventListener("keydown", function(){
        console.log("login key down");
        loginErrors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    emailInput.addEventListener("keydown", function(){
        console.log("email key down");
        emailErrors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });

    passwordInput.addEventListener("keydown", function(){
        console.log("password key down");
        passwordErrors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });
});