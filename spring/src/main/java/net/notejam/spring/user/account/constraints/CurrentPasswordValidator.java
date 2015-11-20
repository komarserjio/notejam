package net.notejam.spring.user.account.constraints;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;

import net.notejam.spring.security.SecurityService;
import net.notejam.spring.user.UserService;

@Configurable
public class CurrentPasswordValidator implements ConstraintValidator<CurrentPassword, String> {
	
	@Autowired
	private UserService userService;
	
	@Autowired
	private SecurityService securityService;

	@Override
	public void initialize(CurrentPassword constraintAnnotation) {
	}

	@Override
	public boolean isValid(String password, ConstraintValidatorContext context) {
		if (password == null) {
			return true;
		}
		return securityService.isPasswordValid(userService.getAuthenticatedUser(), password);
	}

}
