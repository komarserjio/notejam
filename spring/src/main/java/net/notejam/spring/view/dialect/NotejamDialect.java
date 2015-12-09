package net.notejam.spring.view.dialect;

import java.util.HashSet;
import java.util.Set;

import org.thymeleaf.dialect.AbstractDialect;
import org.thymeleaf.processor.IProcessor;

/**
 * The Notejam view dialect.
 *
 * The prefix of this dialect is "notejam". These are the dialect's attributes:
 *
 * <li>date: Formats a date into natural language.
 * <li>text: Converts empty lines into paragraphs.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public final class NotejamDialect extends AbstractDialect {

    @Override
    public String getPrefix() {
        return "notejam";
    }

    @Override
    public Set<IProcessor> getProcessors() {
        Set<IProcessor> processors = new HashSet<IProcessor>();
        processors.add(new NaturalLanguageDateProcessor("date"));
        processors.add(new NoteTextProcessor("text"));
        return processors;
    }

}
