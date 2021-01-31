export class Route {   
    static AppBase = "http://probe.local:8080";
    static HomeDisplay = this.AppBase;
    static UserLogin = this.AppBase + "/User/Login";
    static UserLogout = this.AppBase + "/User/Logout";
    static PollAdd = this.AppBase + "/Poll/Add";
}