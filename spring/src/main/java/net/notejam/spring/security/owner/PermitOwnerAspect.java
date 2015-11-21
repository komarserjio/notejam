package net.notejam.spring.security.owner;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.annotation.AfterReturning;
import org.aspectj.lang.annotation.Aspect;
import org.aspectj.lang.annotation.Before;
import org.aspectj.lang.annotation.Pointcut;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;
import org.springframework.security.access.AccessDeniedException;

import net.notejam.spring.helper.reflection.Annotated;
import net.notejam.spring.helper.reflection.ReflectionUtils;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserService;

/**
 * Grant access only to the authenticated owner of an object.
 * 
 * @author markus@malkusch.de
 * 
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 * @see Owned
 * @see PermitOwner
 */
@Aspect
@Configurable
public class PermitOwnerAspect {

    @Autowired
    private UserService userService;

    @Pointcut("execution(* *(.., @PermitOwner (*), ..))")
    private void restrictOwnedEntities() {
    }

    @Before("net.notejam.spring.security.owner.PermitOwnerAspect.restrictOwnedEntities()")
    public void authorizeCall(JoinPoint joinPoint) {
        for (Annotated<PermitOwner, Owned> annotated : ReflectionUtils
                .<PermitOwner, Owned> getAnnotatedArguments(PermitOwner.class, joinPoint)) {
            if (annotated.getObject() == null) {
                continue;

            }
            authorize(annotated.getObject());

        }
    }

    @Pointcut("execution(@PermitOwner * *(..))")
    private void restrictOwnedResults() {
    }

    @AfterReturning(pointcut = "net.notejam.spring.security.owner.PermitOwnerAspect.restrictOwnedResults()", returning = "entity", argNames = "entitiy")
    public void authorizeReturn(Owned entity) {
        authorize(entity);
    }

    private void authorize(Owned owned) {
        User user = userService.getAuthenticatedUser();

        if (user == null) {
            throw new AccessDeniedException(String.format("%s needs an authenticated user.", owned));
        }

        if (owned.getUser().getId().equals(user.getId())) {
            return;

        } else {
            throw new AccessDeniedException(String.format("User %s is not allowed to access object of user %s.",
                    user.getId(), owned.getUser().getId()));
        }
    }

}
