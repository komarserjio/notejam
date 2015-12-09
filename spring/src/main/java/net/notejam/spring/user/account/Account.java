package net.notejam.spring.user.account;

import javax.validation.constraints.NotNull;

import org.hibernate.validator.constraints.NotEmpty;

import de.malkusch.validation.constraints.EqualProperties;
import net.notejam.spring.user.account.constraints.CurrentPassword;
import net.notejam.spring.user.constraints.Password;

/**
 * Account Settings.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@EqualProperties(value = { "repeatedPassword", "newPassword" }, violationOnPropery = true)
public class Account {

    /**
     * The current password.
     */
    @NotEmpty
    @CurrentPassword
    private String currentPassword;

    /**
     * The new password.
     */
    @Password
    private String newPassword;

    /**
     * The new and repeated password.
     */
    @NotNull
    private String repeatedPassword;

    /**
     * Returns the current password.
     *
     * @return The current password.
     */
    public String getCurrentPassword() {
        return currentPassword;
    }

    /**
     * Sets the current password.
     *
     * @param currentPassword
     *            The current password.
     */
    public void setCurrentPassword(final String currentPassword) {
        this.currentPassword = currentPassword;
    }

    /**
     * Returns the new password.
     *
     * @return The new password.
     */
    public String getNewPassword() {
        return newPassword;
    }

    /**
     * Sets the new password.
     *
     * @param newPassword
     *            The new password.
     */
    public void setNewPassword(final String newPassword) {
        this.newPassword = newPassword;
    }

    /**
     * Returns the new and repeated password.
     *
     * @return The repeated password.
     */
    public String getRepeatedPassword() {
        return repeatedPassword;
    }

    /**
     * Sets the new and repeated password.
     *
     * @param repeatedPassword
     *            The new and repeated password.
     */
    public void setRepeatedPassword(final String repeatedPassword) {
        this.repeatedPassword = repeatedPassword;
    }

}
