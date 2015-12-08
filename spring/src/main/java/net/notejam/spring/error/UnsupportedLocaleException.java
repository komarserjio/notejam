package net.notejam.spring.error;

import org.springframework.context.NoSuchMessageException;

/**
 * An exception for an unsupported locale.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class UnsupportedLocaleException extends Exception {

    private static final long serialVersionUID = 1370162885847665856L;

    /**
     * Constructs a new exception with the specified detail message.
     *
     * @param message
     *            the detail message. The detail message is saved for later
     *            retrieval by the {@link #getMessage()} method.
     * @param cause
     *            the cause (which is saved for later retrieval by the
     *            {@link #getCause()} method). (A <tt>null</tt> value is
     *            permitted, and indicates that the cause is nonexistent or
     *            unknown.)
     */
    public UnsupportedLocaleException(final String message, final NoSuchMessageException cause) {
        super(message, cause);
    }

}
