import * as Message from "../../Resources/Message/User/UserMessage.js";

export class PasswordChecker {
    set Password (password) { this._password = password; }
    get Password () { return this._password; }
    get Errors () { return this._errors; }

    constructor() {
        this._errors = [];
    }

    Execute() {
        this._errors = [];

        // Dans le cas où le mot de passe n'est pas renseigné.
        if (!this._password) {
            this._errors.push(Message.UserMessage.PasswordEmpty);
        }
    }
}