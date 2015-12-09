package net.notejam.spring;

/**
 * URI templates.
 *
 * @author markus@malkusch.de
 *
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 * @see <a href=
 *      "https://github.com/komarserjio/notejam/blob/master/contribute.rst#pages">
 *      Requirements</a>
 */
public interface URITemplates {

    /**
     * The sign up path.
     */
    String SIGNUP = "/signup";

    /**
     * The sign in path.
     */
    String SIGNIN = "/signin";

    /**
     * The sign out path.
     */
    String SIGNOUT = "/signout";

    /**
     * The settings path.
     */
    String SETTINGS = "/settings";

    /**
     * The forgot password path.
     */
    String FORGOT_PASSWORD = "/forgot-password";

    /**
     * The recover password path.
     */
    String RECOVER_PASSWORD = "/recover-password/{id}/{token}";

    /**
     * The create pad path.
     */
    String CREATE_PAD = "/pads/create";

    /**
     * The edit pad path.
     */
    String EDIT_PAD = "/pads/{id}/edit";

    /**
     * The view pad path.
     */
    String VIEW_PAD = "/pads/{id}";

    /**
     * The delete pad path.
     */
    String DELETE_PAD = "/pads/{id}/delete";

    /**
     * The create note path.
     */
    String CREATE_NOTE = "/notes/create";

    /**
     * The create note with a preselected pad path.
     */
    String CREATE_NOTE_FOR_PAD = CREATE_NOTE + "?pad={id}";

    /**
     * The edit note path.
     */
    String EDIT_NOTE = "/notes/{id}/edit";

    /**
     * The view note path.
     */
    String VIEW_NOTE = "/notes/{id}";

    /**
     * The delete note path.
     */
    String DELETE_NOTE = "/notes/{id}/delete";

    /**
     * The view all notes path. This is the default path.
     */
    String VIEW_ALL_NOTES = "/";

}
