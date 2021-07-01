package net.notejam.spring.security;

import org.springframework.stereotype.Controller;
import org.springframework.web.servlet.config.annotation.ViewControllerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurerAdapter;

import net.notejam.spring.URITemplates;

/**
 * Login controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
public class LoginController extends WebMvcConfigurerAdapter {

    @Override
    public void addViewControllers(final ViewControllerRegistry registry) {
        registry.addViewController(URITemplates.SIGNIN).setViewName("user/login");
    }

}
