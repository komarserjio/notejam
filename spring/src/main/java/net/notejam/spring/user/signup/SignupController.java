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
 * Sign up controller
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.SIGNUP)
public class SignupController {

    @Autowired
    private UserService userService;

    @RequestMapping(method = RequestMethod.GET)
    public String showForm(@ModelAttribute("user") Signup user) {
        return "user/signup";
    }

    @RequestMapping(method = RequestMethod.POST)
    public String signup(@Valid @ModelAttribute("user") Signup user, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "user/signup";
        }

        userService.signUp(user.getEmail(), user.getPassword());

        return String.format("redirect:%s?signup", URITemplates.SIGNIN);
    }

}
