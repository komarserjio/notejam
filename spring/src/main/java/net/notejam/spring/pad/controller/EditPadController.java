package net.notejam.spring.pad.controller;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The edit pad controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.EDIT_PAD)
@PreAuthorize("isAuthenticated()")
@Pads
public class EditPadController {

    /**
     * The pad service.
     */
    @Autowired
    private PadService service;

    /**
     * Provides the model attribute "pad".
     *
     * @param id
     *            The pad id.
     * @return The model attribute "pad".
     */
    @ModelAttribute
    public Pad pad(@PathVariable("id") final int id) {
        return service.getPad(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    /**
     * Shows the form for creating a pad.
     *
     * @return The view
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showCreatePadForm() {
        return "pad/edit";
    }

    /**
     * Shows the form for creating a pad.
     *
     * @param pad
     *            the Pad
     * @param bindingResult
     *            The validation result.
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String editPad(@Valid final Pad pad, final BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "pad/edit";
        }

        service.savePad(pad);

        return String.format("redirect:%s", buildEditedPadUri(pad.getId()));
    }

    /**
     * Builds the URI for the edited pad.
     *
     * @param id
     *            The pad id
     * @return The URI
     */
    private static String buildEditedPadUri(final int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.EDIT_PAD);
        uriBuilder.queryParam("success");
        return uriBuilder.buildAndExpand(id).toUriString();
    }

}
