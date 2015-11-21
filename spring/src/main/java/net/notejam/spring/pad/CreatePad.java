package net.notejam.spring.pad;

import net.notejam.spring.pad.constraints.Name;

/**
 * The view pad.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class CreatePad {

    @Name
    private String name;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

}
