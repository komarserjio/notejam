package net.notejam.spring.note.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.util.UriComponentsBuilder;

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

    @Autowired
    private NoteService service;

    @ModelAttribute
    public Note note(@PathVariable("id") int id) {
        return service.getNote(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    @ModelAttribute("cancelURI")
    public String cancelURI(@PathVariable("id") int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.VIEW_NOTE);
        return uriBuilder.buildAndExpand(id).toUriString();
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
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String deleteNote(Note note) {
        service.deleteNote(note);
        return String.format("redirect:%s?deleted", URITemplates.CREATE_NOTE);
    }

}
