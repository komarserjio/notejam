package net.notejam.spring.user.account.constraints;

import javax.validation.ConstraintValidator;
import javax.validation.ConstraintValidatorContext;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;

import net.notejam.spring.security.SecurityService;
import net.notejam.spring.user.UserService;

/**
 * A password validator. The validator matches the encoded password against the
 * currently authenticated user.
 * 
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Configurable
public class CurrentPasswordValidator implements ConstraintValidator<CurrentPassword, String> {

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * The security service.
     */
    @Autowired
    private SecurityService securityService;

    @Override
    public void initialize(final CurrentPassword constraintAnnotation) {
        // Nothing to initialize.
    }

    @Override
    public boolean isValid(final String password, final ConstraintValidatorContext context) {
        if (password == null) {
            return true;
        }
        return securityService.isPasswordValid(userService.getAuthenticatedUser(), password);
    }

}
