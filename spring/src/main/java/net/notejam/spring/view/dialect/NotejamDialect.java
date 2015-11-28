package net.notejam.spring.view.dialect;

import java.util.HashSet;
import java.util.Set;

import org.thymeleaf.dialect.AbstractDialect;
import org.thymeleaf.processor.IProcessor;

import net.notejam.spring.view.dialect.processor.NaturalLanguageDateProcessor;

/**
 * The Notejam view dialect.
 * 
 * The prefix of this dialect is "notejam". These are the dialect's attributes:
 * 
 * - date: Formats a date into natural language.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class NotejamDialect extends AbstractDialect {

    @Override
    public String getPrefix() {
        return "notejam";
    }

    @Override
    public Set<IProcessor> getProcessors() {
        Set<IProcessor> processors = new HashSet<IProcessor>();
        processors.add(new NaturalLanguageDateProcessor("date"));
        return processors;
    }

}
