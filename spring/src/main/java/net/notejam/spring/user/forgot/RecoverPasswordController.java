package net.notejam.spring.user.forgot;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseStatus;

import net.notejam.spring.URITemplates;

/**
 * The password recovery controller will reveal the password in exchange for a
 * token.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
public class RecoverPasswordController {

    @Autowired
    private PasswordRecoveryService recoveryService;

    @RequestMapping(URITemplates.RECOVER_PASSWORD)
    public String revealPassword(@PathVariable("id") int id, @PathVariable("token") String token,
            @ModelAttribute("password") StringBuffer password) throws InvalidTokenException {

        password.append(recoveryService.recoverPassword(id, token));
        return "user/reveal-password";
    }

    @ExceptionHandler(InvalidTokenException.class)
    @ResponseStatus(HttpStatus.NOT_FOUND)
    public String handleInvalidToken() {
        return "error";
    }

}
