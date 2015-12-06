package net.notejam.spring.user.constraints;

import static java.lang.annotation.ElementType.ANNOTATION_TYPE;
import static java.lang.annotation.ElementType.FIELD;
import static java.lang.annotation.ElementType.METHOD;
import static java.lang.annotation.RetentionPolicy.RUNTIME;

import java.lang.annotation.Documented;
import java.lang.annotation.Retention;
import java.lang.annotation.Target;

import javax.validation.Constraint;
import javax.validation.Payload;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.NotEmpty;

/**
 * The password constraints.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Target({ METHOD, FIELD, ANNOTATION_TYPE })
@Retention(RUNTIME)
@Documented
@Size(min = 8, max = 128)
@NotEmpty
@Constraint(validatedBy = {})
public @interface Password {

    /**
     * The validation message.
     */
    String message() default "{Password}";

    /**
     * The validation groups.
     */
    Class<?>[]groups() default {};

    /**
     * This constraint doesn't support any payload.
     */
    Class<? extends Payload>[]payload() default {};

}
