package net.notejam.spring.user.account;

import javax.validation.constraints.NotNull;

import org.hibernate.validator.constraints.NotEmpty;

import de.malkusch.validation.constraints.EqualProperties;
import net.notejam.spring.user.account.constraints.CurrentPassword;
import net.notejam.spring.user.constraints.Password;

/**
 * Account Settings
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@EqualProperties(value = { "repeatedPassword", "newPassword" }, violationOnPropery = true)
public class Account {

    @NotEmpty
    @CurrentPassword
    private String currentPassword;

    @Password
    private String newPassword;

    @NotNull
    private String repeatedPassword;

    public String getCurrentPassword() {
        return currentPassword;
    }

    public void setCurrentPassword(String currentPassword) {
        this.currentPassword = currentPassword;
    }

    public String getNewPassword() {
        return newPassword;
    }

    public void setNewPassword(String newPassword) {
        this.newPassword = newPassword;
    }

    public String getRepeatedPassword() {
        return repeatedPassword;
    }

    public void setRepeatedPassword(String repeatedPassword) {
        this.repeatedPassword = repeatedPassword;
    }

}
