package net.notejam.spring.user;

import javax.validation.groups.Default;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.servlet.config.annotation.ViewControllerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurerAdapter;

import net.notejam.spring.user.validator.UniqueEmail.UserInput;

/**
 * Sign up controller
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping("/signup")
public class SignupController extends WebMvcConfigurerAdapter {

	@Autowired
	private UserService userService;

	@RequestMapping(method=RequestMethod.GET)
	public String showForm(@ModelAttribute("user") SignupUser user) {
		return "signup";
	}
	
	@RequestMapping(method=RequestMethod.POST)
	public String signup(@Validated({UserInput.class, Default.class}) @ModelAttribute("user") SignupUser user, BindingResult bindingResult) {
		if (bindingResult.hasErrors()) {
            return "signup";
        }

		userService.signUp(user);

		return "redirect:/signedup";
	}
	
	@Override
	public void addViewControllers(ViewControllerRegistry registry) {
		registry.addViewController("/signedup").setViewName("signedup");
	}
	
}
