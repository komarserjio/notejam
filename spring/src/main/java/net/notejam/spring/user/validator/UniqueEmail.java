package net.notejam.spring.user.validator;

import static java.lang.annotation.ElementType.FIELD;
import static java.lang.annotation.RetentionPolicy.RUNTIME;

import java.lang.annotation.Documented;
import java.lang.annotation.Retention;
import java.lang.annotation.Target;

import javax.validation.Constraint;
import javax.validation.Payload;
import javax.validation.groups.Default;

/**
 * Validation for a unique email property.
 * 
 * The validator uses a JPA entity manager. I.e. this validation
 * should not happen again during a JPA life cycle event (i.e. validation
 * during persistence). Therefore use this validator only against non {@link Default}
 * validation groups e.g. {@link UserInput}.
 * 
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Target(FIELD)
@Retention(RUNTIME)
@Constraint(validatedBy = UniqueEmailValidator.class)
@Documented
public @interface UniqueEmail {
	
	/**
	 * Validation group which indicates user input.
	 * 
	 * @author markus@malkusch.de
	 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
	 */
	public static interface UserInput {
	}

	String message() default "{UniqueEmail}";

    Class<?>[] groups() default {};

    Class<? extends Payload>[] payload() default {};
	
}
