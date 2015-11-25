package net.notejam.spring.pad.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The view pad notes controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@PreAuthorize("isAuthenticated()")
@Pads
public class ViewPadNotesController {

    @Autowired
    private PadService service;

    @ModelAttribute
    public Pad pad(@PathVariable("id") int id) {
        return service.getPad(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    /**
     * Shows the pad notes
     * 
     * @return The pad notes view
     */
    @RequestMapping(URITemplates.VIEW_PAD)
    public String viewPadNotes() {
        return "pad/view";
    }

}
