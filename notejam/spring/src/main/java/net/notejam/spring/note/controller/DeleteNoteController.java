package net.notejam.spring.note.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The delete note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.DELETE_NOTE)
@PreAuthorize("isAuthenticated()")
@Pads
public class DeleteNoteController {

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
     * Shows the confirmation for deleting a note.
     *
     * @return The view
     */
    @RequestMapping(method = RequestMethod.GET)
    public String confirmDeleteNote() {
        return "note/delete";
    }

    /**
     * Deletes a note.
     *
     * @param note
     *            The note.
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String deleteNote(final Note note) {
        service.deleteNote(note);
        return String.format("redirect:%s?deleted", URITemplates.CREATE_NOTE);
    }

}
