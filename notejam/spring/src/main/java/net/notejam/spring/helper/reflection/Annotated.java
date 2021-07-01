package net.notejam.spring.helper.reflection;

import java.lang.annotation.Annotation;

/**
 * Representation of an annotated object.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 *
 * @param <K> The annotated object type.
 * @param <T> The annotation.
 */
public final class Annotated<T extends Annotation, K> {

    /**
     * The annotation.
     */
    private T annotation;

    /**
     * The annotated object.
     */
    private K object;

    /**
     * Returns the annotation.
     *
     * @return The annotation.
     */
    public T getAnnotation() {
        return annotation;
    }

    /**
     * Sets the annotation.
     *
     * @param annotation The annotation.
     */
    public void setAnnotation(final T annotation) {
        this.annotation = annotation;
    }

    /**
     * Returns the annotated object.
     *
     * @return The annotated object.
     */
    public K getObject() {
        return object;
    }

    /**
     * Sets the annotated object.
     *
     * @param object The annotated object.
     */
    public void setObject(final K object) {
        this.object = object;
    }

}
