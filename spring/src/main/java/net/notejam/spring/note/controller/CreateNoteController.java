package net.notejam.spring.note.controller;

import javax.validation.Valid;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The create note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.CREATE_NOTE)
@PreAuthorize("isAuthenticated()")
@Pads
public class CreateNoteController {

    /**
     * The note service.
     */
    @Autowired
    private NoteService service;

    /**
     * Provides the model attribute "note".
     *
     * @param padId
     *            The preselected pad id.
     * @return The model attribute "note".
     */
    @ModelAttribute
    public Note note(@RequestParam(value = "pad", required = false) final Integer padId) {
        return service.buildNote(padId);
    }

    /**
     * Shows the form for creating a note.
     *
     * @return The view
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showCreateNoteForm() {
        return "note/create";
    }

    /**
     * Creates a new note.
     *
     * @param note
     *            The model attribute "note".
     * @param bindingResult
     *            The validation result.
     *
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String createNote(@Valid final Note note, final BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "note/create";
        }

        service.saveNote(note, note.getPad());

        return String.format("redirect:%s", buildCreatedNoteUri(note.getId()));
    }

    /**
     * Builds the URI for the created note.
     *
     * @param id
     *            The note id
     * @return The URI
     */
    private static String buildCreatedNoteUri(final int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.VIEW_NOTE);
        uriBuilder.queryParam("successful");
        return uriBuilder.buildAndExpand(id).toUriString();
    }

}
