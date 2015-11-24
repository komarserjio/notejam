package net.notejam.spring.note.controller;

import java.util.List;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;

/**
 * The create note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.CREATE_NOTE)
@PreAuthorize("isAuthenticated()")
public class CreateNoteController {

    @Autowired
    private NoteService noteService;

    @Autowired
    private PadService padService;

    @ModelAttribute
    public Note note() {
        return noteService.buildNote();
    }

    @ModelAttribute("pads")
    public List<Pad> pads() {
        return padService.getAllPads();
    }

    /**
     * Shows the form for creating a note.
     * 
     * @return The view
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showCreatePadForm() {
        return "note/create";
    }

    /**
     * Creates a new note.
     * 
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String createPad(@Valid Note note, BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "note/create";
        }

        noteService.saveNote(note, note.getPad());

        return String.format("redirect:%s", buildCreatedNoteUri(note.getId()));
    }

    /**
     * Builds the URI for the created note.
     * 
     * @param id
     *            The note id
     * @return The URI
     */
    private String buildCreatedNoteUri(int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.VIEW_NOTE);
        uriBuilder.queryParam("successful");
        return uriBuilder.buildAndExpand(id).toUriString();
    }

}
