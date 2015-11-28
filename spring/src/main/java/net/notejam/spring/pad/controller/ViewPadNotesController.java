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

    @Autowired
    private PadService padService;

    @Autowired
    private NoteService noteService;

    @ModelAttribute
    public Pad pad(@PathVariable("id") int id) {
        return padService.getPad(id).orElseThrow(() -> new ResourceNotFoundException());
    }

    @ModelAttribute("notes")
    public Page<Note> notes(@ModelAttribute Pad pad, @PageableDefault(10) Pageable pageable) {
        return noteService.getPadNotes(pad, pageable);
    }

    /**
     * Shows the pad notes
     * 
     * @return The pad notes view
     */
    @RequestMapping(URITemplates.VIEW_PAD)
    public String viewPadNotes(Pad pad) {
        return "pad/view";
    }

}
