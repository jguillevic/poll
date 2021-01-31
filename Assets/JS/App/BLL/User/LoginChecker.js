import * as Message from "../../Resources/Message/User/UserMessage.js";

export class LoginChecker {
    set Login (login) { this._login = login; }
    get Login () { return this._login; }
    get Errors () { return this._errors; }

    constructor() {
        this._errors = [];
    }

    Execute() {
        this._errors = [];

        // Dans le cas où l'identifiant n'est pas renseigné.
        if (!this._login) {
            this._errors.push(Message.UserMessage.LoginEmpty);
        }
    }
}