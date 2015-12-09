package net.notejam.spring.pad.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
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

    /**
     * The pad service.
     */
    @Autowired
    private PadService padService;

    /**
     * The note service.
     */
    @Autowired
    private NoteService noteService;

    /**
     * Provides the model attribute "pad".
     *
     * @param id
     *            The pad id.
     * @return The model attribute "pad".
     */
    @ModelAttribute
    public Pad pad(@PathVariable("id") final int id) {
        return padService.getPad(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    /**
     * Provides the model attribute "notes". Notes are all notes of the model
     * attribute "pad".
     *
     * @param pad
     *            The pad.
     * @param pageable
     *            The paging.
     * @return The model attribute "notes".
     */
    @ModelAttribute("notes")
    public Page<Note> notes(@ModelAttribute final Pad pad, @PageableDefault(10) final Pageable pageable) {
        return noteService.getPadNotes(pad, pageable);
    }

    /**
     * Shows the pad notes
     *
     * @param pad
     *            The pad.
     * @return The pad notes view
     */
    @RequestMapping(URITemplates.VIEW_PAD)
    public String viewPadNotes(final Pad pad) {
        return "notes";
    }

}
