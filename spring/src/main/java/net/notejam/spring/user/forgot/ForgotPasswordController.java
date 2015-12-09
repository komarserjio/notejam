package net.notejam.spring.user.forgot;

import java.util.Locale;

import javax.servlet.http.HttpServletRequest;
import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;

/**
 * The forgot password controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.FORGOT_PASSWORD)
public class ForgotPasswordController {

    /**
     * The recovery service.
     */
    @Autowired
    private PasswordRecoveryService recoveryService;

    /**
     * Shows the form.
     *
     * @param forgotPassword
     *            The model attribute.
     * @return The view.
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showForm(@ModelAttribute("forgotPassword") final ForgotPassword forgotPassword) {
        return "user/forgot-password";
    }

    /**
     * Starts the recovery process.
     *
     * This will create a token and send an email to finalize the process with
     * the token.
     *
     * @param forgotPassword
     *            The model attribute with the email address.
     * @param bindingResult
     *            The validation result.
     * @param request
     *            The HTTP request
     * @param locale
     *            The resolved locale
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String startPasswordRecoveryProcess(
            @Valid @ModelAttribute("forgotPassword") final ForgotPassword forgotPassword,
            final BindingResult bindingResult, final HttpServletRequest request, final Locale locale) {
        if (bindingResult.hasErrors()) {
            return "user/forgot-password";
        }

        recoveryService.startRecoveryProcess(forgotPassword.getEmail(), buildRequestUriBuilder(request), locale);

        return String.format("redirect:%s?success", URITemplates.FORGOT_PASSWORD);
    }

    /**
     * Build a UriComponentsBuilder from a request.
     *
     * @param request
     *            The request
     * @return The request as a UriComponentsBuilder.
     */
    private static UriComponentsBuilder buildRequestUriBuilder(final HttpServletRequest request) {
        return UriComponentsBuilder.fromUriString(request.getRequestURL().toString());
    }

}
