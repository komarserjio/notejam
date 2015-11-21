package net.notejam.spring;

/**
 * URI templates
 *
 * @author markus@malkusch.de
 *
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 * @see <a href=
 *      "https://github.com/komarserjio/notejam/blob/master/contribute.rst#pages">
 *      Requirements</a>
 */
public interface URITemplates {

    String SIGNUP = "/signup";
    String SIGNIN = "/signin";
    String SIGNOUT = "/signout";
    String SETTINGS = "/settings";
    String FORGOT_PASSWORD = "/forgot-password";
    String RECOVER_PASSWORD = "/recover-password/{id}/{token}";

    String CREATE_PAD = "/pads/create";
    String SHOW_PAD = "/pads/{id}";

}
