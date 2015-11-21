package net.notejam.spring.helper.reflection;

import java.lang.annotation.Annotation;

/**
 * Representation of an annotated object
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class Annotated<T extends Annotation, K> {

    private T annotation;

    private K object;

    public T getAnnotation() {
        return annotation;
    }

    public void setAnnotation(T annotation) {
        this.annotation = annotation;
    }

    public K getObject() {
        return object;
    }

    public void setObject(K object) {
        this.object = object;
    }

}
