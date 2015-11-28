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
    String EDIT_PAD = "/pads/{id}/edit";
    String VIEW_PAD = "/pads/{id}";
    String DELETE_PAD = "/pads/{id}/delete";

    String CREATE_NOTE = "/notes/create";
    String CREATE_NOTE_FOR_PAD = CREATE_NOTE + "?pad={id}";
    String EDIT_NOTE = "/notes/{id}/edit";
    String VIEW_NOTE = "/notes/{id}";
    String DELETE_NOTE = "/notes/{id}/delete";

}
