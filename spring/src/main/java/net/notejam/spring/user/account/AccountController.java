package net.notejam.spring.user.account;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import net.notejam.spring.user.UserService;

/**
 * Account controller
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping("/account")
@PreAuthorize("isAuthenticated()")
public class AccountController {
	
	@Autowired
	private UserService userService;

	@RequestMapping(method=RequestMethod.GET)
	public String showForm(@ModelAttribute("account") Account account) {
		return "account";
	}
	
	@RequestMapping(method=RequestMethod.POST)
	public String signup(@Valid @ModelAttribute("account") Account account, BindingResult bindingResult) {
		if (bindingResult.hasErrors()) {
            return "account";
        }

		userService.changePassword(account.getNewPassword());

		return "redirect:/account?success";
	}
	
}
