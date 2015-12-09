package net.notejam.spring.user.signup;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import net.notejam.spring.URITemplates;
import net.notejam.spring.user.UserService;

/**
 * A sign up controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.SIGNUP)
public class SignupController {

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * Shows the sign up form.
     *
     * @param user
     *            The model attribute "user".
     * @return The view.
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showForm(@ModelAttribute("user") final Signup user) {
        return "user/signup";
    }

    /**
     * Signs up a user.
     *
     * @param user
     *            The new user.
     * @param bindingResult
     *            The validation result.
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String signup(@Valid @ModelAttribute("user") final Signup user, final BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "user/signup";
        }

        userService.signUp(user.getEmail(), user.getPassword());

        return String.format("redirect:%s?signup", URITemplates.SIGNIN);
    }

}
