package net.notejam.spring.note.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The view note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@PreAuthorize("isAuthenticated()")
@Pads
public class ViewNoteController {

    /**
     * The note service.
     */
    @Autowired
    private NoteService service;

    /**
     * Provides the model attribute "note".
     *
     * @param id
     *            The note id.
     * @return The model attribute "note".
     */
    @ModelAttribute
    public Note note(@PathVariable("id") final int id) {
        return service.getNote(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    /**
     * Shows the note
     *
     * @return The note view
     */
    @RequestMapping(URITemplates.VIEW_NOTE)
    public String viewNote() {
        return "note/view";
    }

}
