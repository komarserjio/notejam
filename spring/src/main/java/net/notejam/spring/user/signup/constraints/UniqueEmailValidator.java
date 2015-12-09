package net.notejam.spring.user.signup.constraints;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;

import net.notejam.spring.user.UserService;

/**
 * A unique email validator. This validator checks if the given email address
 * was already registered.
 * 
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Configurable
public class UniqueEmailValidator implements ConstraintValidator<UniqueEmail, String> {

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    @Override
    public void initialize(final UniqueEmail constraintAnnotation) {
        // Nothing to initialize.
    }

    @Override
    public boolean isValid(final String email, final ConstraintValidatorContext context) {
        if (email == null) {
            return true;
        }
        return !userService.isEmailRegistered(email);
    }

}
