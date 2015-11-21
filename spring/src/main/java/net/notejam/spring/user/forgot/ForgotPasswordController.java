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

    @Autowired
    PasswordRecoveryService recoveryService;

    @RequestMapping(method = RequestMethod.GET)
    public String showForm(@ModelAttribute("forgotPassword") ForgotPassword forgotPassword) {
        return "forgot-password";
    }

    @RequestMapping(method = RequestMethod.POST)
    public String startPasswordRecoveryProcess(@Valid @ModelAttribute("forgotPassword") ForgotPassword forgotPassword,
            BindingResult bindingResult, HttpServletRequest request, Locale locale) {
        if (bindingResult.hasErrors()) {
            return "forgot-password";
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
    private UriComponentsBuilder buildRequestUriBuilder(HttpServletRequest request) {
        return UriComponentsBuilder.fromUriString(request.getRequestURL().toString());
    }

}
