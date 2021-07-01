package net.notejam.spring.user.account;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import net.notejam.spring.URITemplates;
import net.notejam.spring.user.UserService;

/**
 * An account controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.SETTINGS)
@PreAuthorize("isAuthenticated()")
public class AccountController {

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * Shows the form.
     *
     * @param account
     *            The account settings.
     * @return The view.
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showForm(@ModelAttribute("account") final Account account) {
        return "user/account";
    }

    /**
     * Changes the password.
     *
     * @param account
     *            The account settings.
     * @param bindingResult
     *            The validation result
     * @return The view.
     */
    @RequestMapping(method = RequestMethod.POST)
    public String changePassword(@Valid @ModelAttribute("account") final Account account,
            final BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "user/account";
        }

        userService.changePassword(account.getNewPassword());

        return String.format("redirect:%s?success", URITemplates.SETTINGS);
    }

}
