package net.notejam.spring.user.account.constraints;

import static java.lang.annotation.ElementType.FIELD;
import static java.lang.annotation.RetentionPolicy.RUNTIME;

import java.lang.annotation.Documented;
import java.lang.annotation.Retention;
import java.lang.annotation.Target;

import javax.validation.Constraint;
import javax.validation.Payload;
import javax.validation.groups.Default;

/**
 * The password should be valid for the currently authenticated user.
 *
 * {@link CurrentPasswordValidator} uses a JPA entity manager. I.e. this
 * validation should not happen again during a JPA life cycle event (i.e.
 * validation during persistence). If this constraint validates an entity, don't
 * validate against the {@link Default} validation group.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Target(FIELD)
@Retention(RUNTIME)
@Constraint(validatedBy = CurrentPasswordValidator.class)
@Documented
public @interface CurrentPassword {

    /**
     * The validation message.
     */
    String message() default "{CurrentPassword}";

    /**
     * The validation groups.
     */
    Class<?>[]groups() default {};

    /**
     * This constraint doesn't support any validation payload.
     */
    Class<? extends Payload>[]payload() default {};

}
