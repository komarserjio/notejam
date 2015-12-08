package net.notejam.spring.view.dialect;

import static net.notejam.spring.view.dialect.ProcessorUtil.getValue;

import java.time.Instant;
import java.util.Date;
import java.util.Locale;

import org.ocpsoft.prettytime.PrettyTime;
import org.thymeleaf.Arguments;
import org.thymeleaf.dom.Element;
import org.thymeleaf.processor.attr.AbstractTextChildModifierAttrProcessor;

/**
 * A natural language date formatter.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
final class NaturalLanguageDateProcessor extends AbstractTextChildModifierAttrProcessor {

    /**
     * Sets the attribute name.
     *
     * @param attributeName
     *            The attribute name.
     */
    NaturalLanguageDateProcessor(final String attributeName) {
        super(attributeName);
    }

    @Override
    protected String getText(final Arguments arguments, final Element element, final String attributeName) {
        Locale locale = arguments.getContext().getLocale();
        Instant instant = getValue(arguments, element, attributeName);

        PrettyTime formatter = new PrettyTime();
        formatter.setLocale(locale);
        return formatter.format(Date.from(instant));
    }

    @Override
    public int getPrecedence() {
        return 12000;
    }

}
