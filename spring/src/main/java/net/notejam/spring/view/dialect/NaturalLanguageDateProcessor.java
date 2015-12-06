package net.notejam.spring.view.dialect;

import java.time.Instant;
import java.util.Date;
import java.util.Locale;

import org.ocpsoft.prettytime.PrettyTime;
import org.thymeleaf.Arguments;
import org.thymeleaf.Configuration;
import org.thymeleaf.dom.Element;
import org.thymeleaf.processor.attr.AbstractTextChildModifierAttrProcessor;
import org.thymeleaf.standard.expression.IStandardExpression;
import org.thymeleaf.standard.expression.IStandardExpressionParser;
import org.thymeleaf.standard.expression.StandardExpressions;

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
        Instant instant = getInstant(arguments, element, attributeName);

        PrettyTime formatter = new PrettyTime();
        formatter.setLocale(locale);
        return formatter.format(Date.from(instant));
    }

    /**
     * Returns the date from the value expression.
     *
     * @param arguments
     *            The arguments.
     * @param element
     *            The element.
     * @param attributeName
     *            The attribute name
     * @return The date.
     */
    private Instant getInstant(final Arguments arguments, final Element element, final String attributeName) {
        Configuration configuration = arguments.getConfiguration();
        String attributeValue = element.getAttributeValue(attributeName);
        IStandardExpressionParser parser = StandardExpressions.getExpressionParser(configuration);
        IStandardExpression expression = parser.parseExpression(configuration, arguments, attributeValue);
        return (Instant) expression.execute(configuration, arguments);
    }

    @Override
    public int getPrecedence() {
        return 12000;
    }

}
