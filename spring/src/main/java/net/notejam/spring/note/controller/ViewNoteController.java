package net.notejam.spring.note.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;
import net.notejam.spring.error.ResourceNotFoundException;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;

/**
 * The view note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@PreAuthorize("isAuthenticated()")
public class ViewNoteController {

    @Autowired
    private NoteService service;

    @ModelAttribute("editURI")
    public String editURI(@PathVariable("id") int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.EDIT_NOTE);
        return uriBuilder.buildAndExpand(id).toUriString();
    }

    @ModelAttribute("deleteURI")
    public String deleteURI(@PathVariable("id") int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.DELETE_NOTE);
        return uriBuilder.buildAndExpand(id).toUriString();
    }

    @ModelAttribute
    public Note note(@PathVariable("id") int id) {
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
