package net.notejam.spring.view.dialect;

import static net.notejam.spring.view.dialect.ProcessorUtil.getValue;

import java.util.List;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import org.thymeleaf.Arguments;
import org.thymeleaf.dom.Element;
import org.thymeleaf.dom.Node;
import org.thymeleaf.dom.Text;
import org.thymeleaf.processor.attr.AbstractChildrenModifierAttrProcessor;

/**
 * A note text formatter.
 *
 * Each empty line in a note's text delimits a paragraph. Paragraphs will be
 * wrapped in &lt;p> elements.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
final class NoteTextProcessor extends AbstractChildrenModifierAttrProcessor {

    /**
     * Sets the attribute name.
     *
     * @param attributeName
     *            The attribute name.
     */
    NoteTextProcessor(final String attributeName) {
        super(attributeName);
    }

    @Override
    protected List<Node> getModifiedChildren(final Arguments arguments, final Element element,
            final String attributeName) {
        String text = getValue(arguments, element, attributeName);
        String[] paragraphTexts = text.trim().split("\\R{2,}");

        return Stream.of(paragraphTexts).map(paragraphText -> {
            Element paragraph = new Element("p");
            paragraph.addChild(new Text(paragraphText));
            return paragraph;
        }).collect(Collectors.toList());
    }

    @Override
    public int getPrecedence() {
        return 12000;
    }

}
