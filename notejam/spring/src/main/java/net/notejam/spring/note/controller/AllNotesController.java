package net.notejam.spring.note.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.Note;
import net.notejam.spring.note.NoteService;
import net.notejam.spring.pad.controller.PadsAdvice.Pads;

/**
 * A controller to show all notes.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Controller
@PreAuthorize("isAuthenticated()")
@Pads
public class AllNotesController {

    /**
     * The note service.
     */
    @Autowired
    private NoteService noteService;

    /**
     * Provide the model attribute "notes".
     *
     * @param pageable The paging.
     * @return The model attribute "notes".
     */
    @ModelAttribute("notes")
    public Page<Note> notes(@PageableDefault(10) final Pageable pageable) {
        return noteService.getNotes(pageable);
    }

    /**
     * Shows all notes.
     *
     * @return The view.
     */
    @RequestMapping(URITemplates.VIEW_ALL_NOTES)
    public String showAllNotes() {
        return "notes";
    }

}
