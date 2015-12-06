package net.notejam.spring.pad.controller;

import java.lang.annotation.ElementType;
import java.lang.annotation.Retention;
import java.lang.annotation.RetentionPolicy;
import java.lang.annotation.Target;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ModelAttribute;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * Pads controller advice.
 *
 * This controller advice provides all pads of the authenticated user for the
 * view as the model attribute pads.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@ControllerAdvice(annotations = Pads.class)
@PreAuthorize("isAuthenticated()")
public class PadsAdvice {

    /**
     * Provide all pads of the authenticated user as the model attribute pads.
     *
     * @author markus@malkusch.de
     * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
     */
    @Retention(RetentionPolicy.RUNTIME)
    @Target({ ElementType.TYPE })
    public static @interface Pads {

    }

    /**
     * The pad service.
     */
    @Autowired
    private PadService service;

    /**
     * Provides the model attribute "pads". I.e. all pads of the currently
     * authenticated user.
     *
     * @return The model attribute "pads".
     */
    @ModelAttribute("pads")
    public List<Pad> pads() {
        return service.getAllPads();
    }

}
