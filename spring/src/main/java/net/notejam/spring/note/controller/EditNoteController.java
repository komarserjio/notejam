package net.notejam.spring.note.controller;

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
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * The edit note controller.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@RequestMapping(URITemplates.EDIT_NOTE)
@PreAuthorize("isAuthenticated()")
@Pads
public class EditNoteController {

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
     * Shows the form for editing a note.
     *
     * @return The view
     */
    @RequestMapping(method = RequestMethod.GET)
    public String showEditNoteForm() {
        return "note/edit";
    }

    /**
     * Edits a new note.
     *
     * @param note
     *            The note.
     * @param bindingResult
     *            The validation result.
     * @return The view
     */
    @RequestMapping(method = RequestMethod.POST)
    public String editNote(@Valid final Note note, final BindingResult bindingResult) {
        if (bindingResult.hasErrors()) {
            return "note/edit";
        }

        service.saveNote(note, note.getPad());

        return String.format("redirect:%s", buildEditedNoteUri(note.getId()));
    }

    /**
     * Builds the URI for the edited note.
     *
     * @param id
     *            The note id
     * @return The URI
     */
    private static String buildEditedNoteUri(final int id) {
        UriComponentsBuilder uriBuilder = UriComponentsBuilder.fromPath(URITemplates.VIEW_NOTE);
        uriBuilder.queryParam("successful");
        return uriBuilder.buildAndExpand(id).toUriString();
    }

}
