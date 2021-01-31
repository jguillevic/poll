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

    passwordInput.addEventListener("keydown", function(){
        console.log("password key down");
        passwordErrors.innerHTML = "";
        this.setCustomValidity("");
        this.classList.remove("is-invalid");
    });
    
    form.addEventListener("submit", function(e) {
        console.log("user login form submit");

        let login = loginInput.value;
        let loginChecker = new LoginChecker.LoginChecker();
        loginChecker.Login = login;
        loginChecker.Execute();
        if (loginChecker.Errors.length > 0 ) {
            loginInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
        }
        loginChecker.Errors.forEach(error => {
            let p = document.createElement("p");
            p.innerHTML = error;
            loginErrors.appendChild(p);
        });

        let password = passwordInput.value;
        let passwordChecker = new PasswordChecker.PasswordChecker();
        passwordChecker.Password = password;
        passwordChecker.Execute();
        if (passwordChecker.Errors.length > 0 ) {
            passwordInput.setCustomValidity(Message.CommonMessage.InputNotValidMessage);
        }
        passwordChecker.Errors.forEach(error => {
            let p = document.createElement("p");
            p.innerHTML = error;
            passwordErrors.appendChild(p);
        });

        if (loginChecker.Errors.length > 0 
            || passwordChecker.Errors.length > 0) {
            e.preventDefault();
            e.stopPropagation();

            form.classList.add("was-validated");
        }
    });
});