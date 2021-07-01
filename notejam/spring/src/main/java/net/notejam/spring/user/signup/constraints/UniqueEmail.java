package net.notejam.spring.user.signup.constraints;

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
 * {@link UniqueEmailValidator} uses a JPA entity manager. I.e. this validation
 * should not happen again during a JPA life cycle event (i.e. validation during
 * persistence). If this constraint validates an entity, don't validate against
 * the {@link Default} validation group.
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
     * The validation message.
     */
    String message() default "{UniqueEmail}";

    /**
     * The validation groups.
     */
    Class<?>[]groups() default {};

    /**
     * This constraint doesn't support any payload.
     */
    Class<? extends Payload>[]payload() default {};

}
