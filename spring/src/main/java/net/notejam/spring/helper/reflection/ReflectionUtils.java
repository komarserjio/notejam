package net.notejam.spring.helper.reflection;

import java.lang.annotation.Annotation;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.List;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.reflect.MethodSignature;

/**
 * Reflection utils.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public final class ReflectionUtils {

    /**
     * No public constructor for this utility class.
     */
    private ReflectionUtils() {
    }

    /**
     * Returns a list of arguments which have a given annotation.
     *
     * @param annotation
     *            The annotation
     * @param joinPoint
     *            The join point
     * @param <T>
     *            The annotation.
     * @param <P>
     *            The annotated object type.
     *
     * @return The matching objects.
     */
    public static <T extends Annotation, P> List<Annotated<T, P>> getAnnotatedArguments(final Class<T> annotation,
            final JoinPoint joinPoint) {
        Method method = ((MethodSignature) joinPoint.getSignature()).getMethod();
        Object[] arguments = joinPoint.getArgs();
        return getAnnotatedArguments(annotation, method, arguments);
    }

    /**
     * Returns a list of arguments which have a given annotation.
     *
     * @param annotation
     *            The annotation
     * @param method
     *            The method
     * @param arguments
     *            The method arguments
     * @param <T>
     *            The annotation.
     * @param <P>
     *            The annotated object type.
     *
     * @return The matching objects.
     */
    @SuppressWarnings("unchecked")
    public static <T extends Annotation, P> List<Annotated<T, P>> getAnnotatedArguments(final Class<T> annotation,
            final Method method, final Object[] arguments) {
        List<Annotated<T, P>> match = new ArrayList<>();
        int i = 0;
        for (Annotation[] annotations : method.getParameterAnnotations()) {
            for (Annotation paramAnotation : annotations) {
                if (annotation.isAssignableFrom(paramAnotation.annotationType())) {
                    Annotated<T, P> annotated = new Annotated<>();
                    annotated.setAnnotation((T) paramAnotation);
                    annotated.setObject((P) arguments[i]);
                    match.add(annotated);

                }
            }
            i++;
        }
        return match;
    }

}
