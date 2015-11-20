package net.notejam.spring.user.signup.constraints;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;

import net.notejam.spring.user.UserService;

@Configurable
public class UniqueEmailValidator implements ConstraintValidator<UniqueEmail, String> {
	
	@Autowired
	private UserService userService;

	@Override
	public void initialize(UniqueEmail constraintAnnotation) {
	}

	@Override
	public boolean isValid(String email, ConstraintValidatorContext context) {
		if (email == null) {
			return true;
		}
		return ! userService.isEmailRegistered(email);
	}

}
